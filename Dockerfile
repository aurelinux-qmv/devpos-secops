# Sử dụng base image Debian 12 slim
FROM debian:12-slim

LABEL maintainer="Quan Vo"

# --- BIẾN MÔI TRƯỜNG VÀ THAM SỐ BUILD ---
ENV DEBIAN_FRONTEND=noninteractive
ARG PHP_VERSION=8.2

# --- CÀI ĐẶT HỆ THỐNG ---
RUN apt-get update && \
    # 1. Cài các gói tạm thời để thêm repo
    apt-get install -y --no-install-recommends \
        curl wget gnupg2 lsb-release ca-certificates \
    && \
    # 2. Thêm repo PHP của Sury
    curl -sSLo /usr/share/keyrings/sury-php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb [signed-by=/usr/share/keyrings/sury-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list && \
    # 3. Cài các gói cần thiết cho runtime
    apt-get update && \
    apt-get install -y --no-install-recommends \
        nginx supervisor \
        php${PHP_VERSION}-fpm php${PHP_VERSION}-cli php${PHP_VERSION}-common php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-curl php${PHP_VERSION}-mbstring php${PHP_VERSION}-xml php${PHP_VERSION}-gd \
    && \
    # 4. Dọn dẹp triệt để
    apt-get purge -y --auto-remove curl wget gnupg2 lsb-release ca-certificates && \
    rm -rf /var/lib/apt/lists/*

# --- CẤU HÌNH THƯ MỤC VÀ QUYỀN ---
WORKDIR /var/www

# Sao chép mã nguồn và gán quyền sở hữu cho www-data
COPY --chown=www-data:www-data ./maytinh .

# Sao chép các file cấu hình cần thiết
COPY nginx.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY www.conf /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf

# Tạo các thư mục cần thiết và gán quyền cho www-data
RUN mkdir -p /run/php && \
    chown -R www-data:www-data /run/php && \
    chown -R www-data:www-data /var/lib/nginx

# --- CHẠY CONTAINER ---
# Chuyển sang người dùng www-data
# USER www-data

# Mở port 80
EXPOSE 80

# Healthcheck
HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl --fail http://127.0.0.1/ || exit 1

# Lệnh sẽ được chạy khi container khởi động
CMD /usr/bin/supervisord -n
